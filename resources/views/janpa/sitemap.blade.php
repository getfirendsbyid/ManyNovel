<urlset>
    @foreach($data as $item)
    <url>
        <loc>http://{{$item->enname}}.{{$host->host}}</loc>
        <lastmod>{{date('Y-m-d')}}</lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
    @foreach($data as $item)
    <url>
        <loc>http://www.{{$host->host}}/book/{{$item->enname}}.html</loc>
        <lastmod>{{date('Y-m-d')}}</lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
        @endforeach
</urlset>