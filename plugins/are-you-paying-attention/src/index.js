//alert ("Hello from test.js!");
wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: 'Are You Paying Attention?',
    icon: 'smiley',
    category: 'common',
    attributes: {
        skyColour: { type: "string" },
        grassColour: {type: "string"}
    },
    edit: function ($props) {
        //wp.element.createElement("h3", null, "Hello from the editor - this is h3!");
        function updateSkyColour($event) {
            $props.setAttribute({ skyColour: $event.target.value });
            return (
                <div>
                    {/*<p>Hello - this is a paragraph from JSX.</p>
                <h2>Hello there - this is h2 from JSK.</h2>*/}
                    <input type="text" placeholder="sky colour" value={$props.attributes.skyColour} onChange={updateSkyColour} />
                </div>
            );
        }
        function updateGrassColour($event) {
            props.setAttribute({ grassColour: $event.target.value });
            return (
                <div>
                    <input type="text" placeholder="grass colour" 
                        value={$props.attributes.grassColour} onChange={updateGrassColour} />
                </div>
            )
        }
        
    },
    save: function ($props) {
        //wp.element.createElement("h1", null, "Hello from the frontend - this is h1!");
        return ( 
            <p>Today the sky is {$props.attributes.skyColour} and the grass is {$props.attributes.grassColour}.</p>
        );

        
    }
} );

