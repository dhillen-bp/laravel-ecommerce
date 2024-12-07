import "./bootstrap";
import "flyonui/flyonui";

import '../../vendor/masmerise/livewire-toaster/resources/js';

document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
});
