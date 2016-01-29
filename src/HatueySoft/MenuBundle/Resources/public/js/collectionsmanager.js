var CollectionsManager = function (collectionHolderSelect, addLinkSelector, deleteLinkSelector) {
    this.collectionHolder = $(collectionHolderSelect);
    this.deleteLinkSelector = deleteLinkSelector;
    this.addLinkSelector = addLinkSelector;
};

CollectionsManager.prototype = {
    init: function () {
        var self = this,
            index = self.collectionHolder.find(self.deleteLinkSelector).length;
        if (index != 0) {
            self.collectionHolder.data('index', index);
        }

        self.updateDeleteLink();
        self.updateView();

        $(self.addLinkSelector).off('click').on('click', {instance: self}, self.addTagForm);
    },

    addTagForm: function (event) {
        event.preventDefault();

        var self = event.data.instance,
            prototype, index, newForm;

        // Get the data-prototype explained earlier
        prototype = self.collectionHolder.data('prototype');

        // get the new index
        index = self.collectionHolder.data('index');
        if (typeof index == 'undefined') {
            index = 0;
        }

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        self.collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        self.collectionHolder.find('#tbody').append(newForm);
        self.updateDeleteLink();
        self.updateView();
    },

    updateDeleteLink: function () {
        var self = this;
        $(self.deleteLinkSelector).off('click').on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the tag form
            $(this).parent().parent().remove();

            self.updateView();
        });
    },

    updateView: function () {
        var self = this,
            counter = self.collectionHolder.find(self.deleteLinkSelector).length;

        if(counter == 0){
            $('div#no-elements-tr').show();
        }else{
            $('div#no-elements-tr').hide();
        }
    }
};
