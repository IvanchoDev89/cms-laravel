<div>
    <h1>Posts Management</h1>
    <p>Testing simple posts view</p>
    @if(isset($posts))
        <p>Posts count: {{ $posts->count() }}</p>
    @endif
</div>
