import ProcessManager from './process.manager.js';

document.addEventListener('DOMContentLoaded', () => {
    try {
        const processManager = new ProcessManager();
        console.log('ProcessManager initialized'); // Debug log
    } catch (error) {
        console.error('Error initializing ProcessManager:', error);
    }
}); 