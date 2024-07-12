const targetNode = document.getElementById('news-list'); // Replace with your target element ID

const config = { childList: true, subtree: true };

const callback = function(mutationsList, observer) {
    for (let mutation of mutationsList) {
        if (mutation.type === 'childList') {
            console.log('A child node has been added or removed.');
            // Perform actions based on DOM changes
        }
    }
};

const observer = new MutationObserver(callback);
observer.observe(targetNode, config);