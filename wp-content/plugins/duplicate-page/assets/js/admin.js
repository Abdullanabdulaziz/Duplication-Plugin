jQuery(document).ready(function($) {
    const container = $('#word-replacements-container');
    const addButton = $('#add-replacement');
    const maxReplacements = parseInt(addButton.data('max-replacements'));

    function updateButtonState() {
        const currentPairs = container.children('.word-replacement-pair').length;
        if (currentPairs >= maxReplacements) {
            addButton.prop('disabled', true);
        } else {
            addButton.prop('disabled', false);
        }

        // Show/hide remove buttons
        container.find('.remove-replacement').toggle(currentPairs > 1);
    }

    function addReplacementPair() {
        const currentPairs = container.children('.word-replacement-pair').length;
        if (currentPairs >= maxReplacements) {
            return;
        }

        const newPair = container.children('.word-replacement-pair').first().clone();
        newPair.find('input').each(function() {
            const name = $(this).attr('name');
            $(this)
                .attr('name', name.replace('[0]', '[' + currentPairs + ']'))
                .val('');
        });

        container.append(newPair);
        updateButtonState();
    }

    function removeReplacementPair(e) {
        e.preventDefault();
        $(this).closest('.word-replacement-pair').remove();
        
        // Reindex remaining pairs
        container.children('.word-replacement-pair').each(function(index) {
            $(this).find('input').each(function() {
                const name = $(this).attr('name');
                $(this).attr('name', name.replace(/\[\d+\]/, '[' + index + ']'));
            });
        });

        updateButtonState();
    }

    // Event handlers
    addButton.on('click', addReplacementPair);
    container.on('click', '.remove-replacement', removeReplacementPair);

    // Initial state
    updateButtonState();
});
