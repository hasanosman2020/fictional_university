//alert ("Hello from test.js!");
wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: 'Are You Paying Attention?',
    icon: 'smiley',
    category: 'common',
    edit: function () {
        wp.element.createElement("h3", null, "Hello from the editor - this is h3!");

        
    },
    save: function () {
        wp.element.createElement("h1", null, "Hello from the frontend - this is h1!");

        
    }
} );

