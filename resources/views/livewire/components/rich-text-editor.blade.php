<div>
    @vite(['resources/js/app.js'])

    <tiptap-editor 
        wire:model="content"
        :model-value='@json($content)'
        @update:model-value="$wire.set('content', $event)"
    ></tiptap-editor>
</div>
