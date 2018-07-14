<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected  $table ='chapter';

    public static function getbooklist($bookid)
    {
       return Chapter::where(['bookid'=>$bookid])->get();
    }

    public static function lasttime($bookid)
    {
        return Chapter::where(['bookid'=>$bookid])->orderby('bookid','desc')->first()->created_at;
    }

    public static function getbody($chapterid)
    {
        return Chapter::find($chapterid)->chapter_content;
    }

    public static function getcname($chapterid)
    {
        return Chapter::find($chapterid)->name;
    }

    public function batchUpdate(array $update, $whenField = 'id', $whereField = 'id')
    {
        $table = $this->getTable();
        $update = collect($update);
        // 判断需要更新的数据里包含有放入when中的字段和where的字段
        if ($update->pluck($whenField)->isEmpty() || $update->pluck($whereField)->isEmpty()) {
            throw new \InvalidArgumentException('argument 1 don\'t have field ' . $whenField);
        }
        $when = [];
        // 拼装sql，相同字段根据不同条件更新不同数据
        foreach ($update->all() as $sets) {
            $whenValue = $sets[$whenField];
            foreach ($sets as $fieldName => $value) {
                if ($fieldName == $whenField) continue;
                if (is_null($value)) $value = 'null';
                $when[$fieldName][] = "when {$whenField} = '{$whenValue}' then '{$value}'";
            }
        }
        $build = \DB::table($table)->whereIn($whereField, $update->pluck($whereField));
        foreach ($when as $fieldName => &$item) {
            $item = \DB::raw("case " . implode(' ', $item) . ' end ');
        }
        $build->update($when);
    }

    public function updateBatch($multipleData = [])
    {
        try {
            if (empty($multipleData)) {
                throw new \Exception("数据不能为空");
            }
            $tableName = \DB::getTablePrefix() . $this->getTable(); // 表名
            $firstRow  = current($multipleData);

            $updateColumn = array_keys($firstRow);
            // 默认以id为条件更新，如果没有ID则以第一个字段为条件
            $referenceColumn = isset($firstRow['id']) ? 'id' : current($updateColumn);
            unset($updateColumn[0]);
            // 拼接sql语句
            $updateSql = "UPDATE " . $tableName . " SET ";
            $sets      = [];
            $bindings  = [];
            foreach ($updateColumn as $uColumn) {
                $setSql = "`" . $uColumn . "` = CASE ";
                foreach ($multipleData as $data) {
                    $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                    $bindings[] = $data[$referenceColumn];
                    $bindings[] = $data[$uColumn];
                }
                $setSql .= "ELSE `" . $uColumn . "` END ";
                $sets[] = $setSql;
            }
            $updateSql .= implode(', ', $sets);
            $whereIn   = collect($multipleData)->pluck($referenceColumn)->values()->all();
            $bindings  = array_merge($bindings, $whereIn);
            $whereIn   = rtrim(str_repeat('?,', count($whereIn)), ',');
            $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $referenceColumn . "` IN (" . $whereIn . ")";
            // 传入预处理sql语句和对应绑定数据
            return \DB::update($updateSql, $bindings);
        } catch (\Exception $e) {
            return false;
        }
    }
    
}
