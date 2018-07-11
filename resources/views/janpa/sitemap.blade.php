<urlset>
    @foreach($data as $item)
    <url>
        <loc>http://{{$item->enname}}.zbtorch.cn</loc>
        <lastmod>{{date('Y-m-d')}}</lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
    @foreach($data as $item)
    <url>
        <loc>http://www.zbtorch.cn/book/{{$item->enname}}.html</loc>
        <lastmod>{{date('Y-m-d')}}</lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
        @endforeach
</urlset>