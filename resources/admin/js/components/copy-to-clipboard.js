Livewire.on('copyToClipboard', ($blockId) => {
    console.log($blockId);
    let text = document.getElementById($blockId).innerHTML;

    navigator.clipboard.writeText(text).then(() => {
        console.log('Content copied to clipboard');
    },() => {
        console.error('Failed to copy');
    });
});
