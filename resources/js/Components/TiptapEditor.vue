<template>
  <div class="w-full">
    <!-- Toolbar -->
    <div class="bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-t-lg p-3 flex flex-wrap gap-2">
      <!-- Text Formatting -->
      <button
        @click="editor.chain().focus().toggleBold().run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('bold'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('bold') }"
        class="px-3 py-2 rounded font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Bold (Ctrl+B)"
      >
        <strong>B</strong>
      </button>

      <button
        @click="editor.chain().focus().toggleItalic().run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('italic'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('italic') }"
        class="px-3 py-2 rounded italic hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Italic (Ctrl+I)"
      >
        I
      </button>

      <button
        @click="editor.chain().focus().toggleUnderline().run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('underline'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('underline') }"
        class="px-3 py-2 rounded underline hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Underline (Ctrl+U)"
      >
        U
      </button>

      <button
        @click="editor.chain().focus().toggleStrike().run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('strike'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('strike') }"
        class="px-3 py-2 rounded line-through hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Strikethrough"
      >
        S
      </button>

      <div class="w-px bg-gray-300 dark:bg-gray-600"></div>

      <!-- Headings -->
      <button
        @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('heading', { level: 1 }), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('heading', { level: 1 }) }"
        class="px-3 py-2 rounded font-bold text-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Heading 1"
      >
        H1
      </button>

      <button
        @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('heading', { level: 2 }), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('heading', { level: 2 }) }"
        class="px-3 py-2 rounded font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Heading 2"
      >
        H2
      </button>

      <button
        @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('heading', { level: 3 }), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('heading', { level: 3 }) }"
        class="px-3 py-2 rounded font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Heading 3"
      >
        H3
      </button>

      <div class="w-px bg-gray-300 dark:bg-gray-600"></div>

      <!-- Lists -->
      <button
        @click="editor.chain().focus().toggleBulletList().run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('bulletList'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('bulletList') }"
        class="px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Bullet List"
      >
        <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
        </svg>
      </button>

      <button
        @click="editor.chain().focus().toggleOrderedList().run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('orderedList'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('orderedList') }"
        class="px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Ordered List"
      >
        <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h1a1 1 0 100-2H4a3 3 0 00-3 3v10a3 3 0 003 3h1a1 1 0 100-2H4a1 1 0 01-1-1V4zm9.22 1.427a1 1 0 011.165.401l2 4a1 1 0 11-1.79.894l-.332-.664h-2.576l-.332.664a1 1 0 11-1.79-.894l2-4a1 1 0 01.555-.4zm.577 4.573h1.577l-.789-1.577-.788 1.577z" clip-rule="evenodd"/>
        </svg>
      </button>

      <button
        @click="editor.chain().focus().toggleCodeBlock().run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('codeBlock'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('codeBlock') }"
        class="px-3 py-2 rounded font-mono hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Code Block"
      >
        {'{'}{'}'}
      </button>

      <div class="w-px bg-gray-300 dark:bg-gray-600"></div>

      <!-- Link & Quote -->
      <button
        @click="setLink"
        :class="{ 'bg-blue-600 text-white': editor.isActive('link'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('link') }"
        class="px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Link"
      >
        <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11 3a1 1 0 100 2h3.586L9.293 9.293a1 1 0 001.414 1.414L16 6.414V10a1 1 0 100 2h-5a1 1 0 01-1-1V4a1 1 0 011-1h3z"/>
          <path d="M5 5a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
        </svg>
      </button>

      <button
        @click="editor.chain().focus().toggleBlockquote().run()"
        :class="{ 'bg-blue-600 text-white': editor.isActive('blockquote'), 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white': !editor.isActive('blockquote') }"
        class="px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Quote"
      >
        <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
          <path d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L12.232 8m-5.477 7.21-.677-3.386a1 1 0 00-.6-.722A3 3 0 003 13m10-1a3 3 0 100-6H9c-4.457 0-8 2.239-8 5c0 1.581.538 3.042 1.446 4.247C3.223 16.146 4.581 17 6 17c.178 0 .353-.021.52-.06A3 3 0 0010 15.891m4.9-2.555a2.376 2.376 0 01-1.957-2.9 2.376 2.376 0 011.735-2.772 2.376 2.376 0 012.4 3.409c-.131.162-.333.322-.537.466l-.892.446z"/>
        </svg>
      </button>

      <div class="w-px bg-gray-300 dark:bg-gray-600"></div>

      <!-- Clear -->
      <button
        @click="editor.chain().focus().clearNodes().run()"
        class="px-3 py-2 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 transition"
        title="Clear Formatting"
      >
        <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
      </button>
    </div>

    <!-- Editor -->
    <div class="border border-t-0 border-gray-300 dark:border-gray-700 rounded-b-lg overflow-hidden">
      <EditorContent
        :editor="editor"
        class="prose dark:prose-invert max-w-none prose-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4"
      />
    </div>

    <!-- Link Dialog -->
    <div v-if="showLinkDialog" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm w-full">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Insert Link</h3>
        <input
          v-model="linkUrl"
          type="url"
          placeholder="https://example.com"
          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <div class="flex gap-2">
          <button
            @click="confirmLink"
            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
          >
            Insert
          </button>
          <button
            @click="showLinkDialog = false"
            class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'
import Underline from '@tiptap/extension-underline'
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue'])

const showLinkDialog = ref(false)
const linkUrl = ref('')

const editor = useEditor({
  content: props.modelValue,
  extensions: [
    StarterKit,
    Link.configure({
      openOnClick: false,
    }),
    Image,
    Underline,
  ],
  onUpdate: () => {
    emit('update:modelValue', editor.value.getHTML())
  },
})

watch(() => props.modelValue, (value) => {
  const isSame = editor.value.getHTML() === value
  if (isSame) return
  editor.value.commands.setContent(value, false)
})

const setLink = () => {
  const previousUrl = editor.value.getAttributes('link').href
  linkUrl.value = previousUrl || ''
  showLinkDialog.value = true
}

const confirmLink = () => {
  if (linkUrl.value === '') {
    editor.value.chain().focus().extendMarkRange('link').unsetLink().run()
  } else {
    editor.value.chain().focus().extendMarkRange('link').setLink({ href: linkUrl.value }).run()
  }
  showLinkDialog.value = false
  linkUrl.value = ''
}
</script>

<style scoped>
:deep(.ProseMirror) {
  min-height: 300px;
  outline: none;
}

:deep(.ProseMirror h1) {
  font-size: 2em;
  font-weight: bold;
  margin: 0.67em 0;
}

:deep(.ProseMirror h2) {
  font-size: 1.5em;
  font-weight: bold;
  margin: 0.75em 0;
}

:deep(.ProseMirror h3) {
  font-size: 1.17em;
  font-weight: bold;
  margin: 0.83em 0;
}

:deep(.ProseMirror ul) {
  list-style-type: disc;
  margin-left: 1.5em;
  margin: 1em 0;
}

:deep(.ProseMirror ol) {
  list-style-type: decimal;
  margin-left: 1.5em;
  margin: 1em 0;
}

:deep(.ProseMirror code) {
  background-color: #f3f4f6;
  color: #1f2937;
  padding: 0.2em 0.4em;
  border-radius: 3px;
  font-family: monospace;
}

:deep(.dark .ProseMirror code) {
  background-color: #374151;
  color: #f3f4f6;
}

:deep(.ProseMirror pre) {
  background-color: #1f2937;
  color: #f3f4f6;
  padding: 1em;
  border-radius: 6px;
  overflow-x: auto;
  margin: 1em 0;
}

:deep(.dark .ProseMirror pre) {
  background-color: #111827;
}

:deep(.ProseMirror blockquote) {
  border-left: 4px solid #3b82f6;
  padding-left: 1em;
  margin-left: 0;
  font-style: italic;
  color: #6b7280;
  margin: 1em 0;
}

:deep(.dark .ProseMirror blockquote) {
  color: #9ca3af;
  border-left-color: #60a5fa;
}

:deep(.ProseMirror a) {
  color: #3b82f6;
  cursor: pointer;
  text-decoration: underline;
}

:deep(.ProseMirror a:hover) {
  color: #1d4ed8;
}

:deep(.dark .ProseMirror a) {
  color: #60a5fa;
}

:deep(.dark .ProseMirror a:hover) {
  color: #93c5fd;
}

:deep(.ProseMirror p) {
  margin: 1em 0;
}
</style>
