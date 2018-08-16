<urlset>
    @foreach($data as $item)
    <url>
        <loc>{{$item}}</loc>
        <lastmod>{{date('Y-m-d')}}</lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach

</urlset>