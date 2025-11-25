import './bootstrap';
import { createApp } from 'vue';
import TiptapEditor from './Components/TiptapEditor.vue';

// Only mount Vue app when document is ready and if there's an app container
document.addEventListener('DOMContentLoaded', () => {
	const appContainers = document.querySelectorAll('[data-vue-app]');
  
	// If there are Vue components to initialize
	if (appContainers.length > 0) {
		const app = createApp({});
		app.component('tiptap-editor', TiptapEditor);
    
		// Mount app to the first container (or create one if needed)
		let mountTarget = document.getElementById('app');
		if (!mountTarget) {
			mountTarget = document.createElement('div');
			mountTarget.id = 'app';
			document.body.appendChild(mountTarget);
		}
		app.mount(mountTarget);
	}
});
