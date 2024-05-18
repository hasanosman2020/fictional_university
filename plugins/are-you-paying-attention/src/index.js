import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from '@wordpress/components'

//alert ("Hello from test.js!");
wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: 'Are You Paying Attention?',
    icon: 'smiley',
    category: 'common',
    attributes: {
        question: { type: "string" },
        answers: {type: "array", default: ["red", "blue", "green"]}
    },
    edit: EditComponents,
    save: function (props) {
        //wp.element.createElement("h1", null, "Hello from the frontend - this is h1!");
        return null; /*( {
            <p>Today the sky is {$props.attributes.skyColour} and the grass is {$props.attributes.grassColour}.</p>*/ }
        
    }
)
 
function EditComponents(props) {
    //function(props) {
        //wp.element.createElement("h3", null, "Hello from the editor - this is h3!");
        //function updateSkyColour(event) {
            //props.setAttribute({ skyColour: event.target.value })
    //}
    //function updateGrassColour(event) {
        //props.setAttribute({ grassColour: event.target.value })
    //}

    function updateQuestion(value) {
        props.setAttributes({question: value})
    }
    function deleteAnswer(indexToDelete) {
        return function () {
            const newAnswers = props.attributes.answers.filter(function (x, index) {
                return index !== indexToDelete;
            });
        
            props.setAttributes({ answers: newAnswers });
        }
    }
            return (
                <div className="paying-attention-edit-block">
                    <TextControl label="Question" value={props.attributes.question} onChange={updateQuestion} style={{ fontSize: "20px" }} />
                    <p style={{ fontSize: "13px", margin: "20px 0 8px 0" }}>Answers:</p>
                    
                    {props.attributes.answers.map(function (answer, index) {
                    
                        return (
                            <Flex>
                                <FlexBlock>
                                    <TextControl value={answer} onChange={newValue => {
                                        const newAnswers = props.attributes.answers.concat([]);
                                        newAnswers[index] = newValue;
                                        props.setAttributes({ answers: newAnswers });
                                    }} />
                                </FlexBlock>
                                <FlexItem>
                                    <Button>
                                        <Icon icon="star-empty" className="mark-as-correct" />
                                    </Button>
                                </FlexItem>
                                <FlexItem>
                                    <Button link className="attention-delete" onClick={deleteAnswer(index)}>DELETE</Button>
                                </FlexItem>
                            </Flex>
                        );
                    })}
                    <Button primary onClick={() => {
                        props.setAttributes({answers: props.attributes.answers.concat([""])})
                    }}>Add Another Answer</Button>
                </div>
            
                
    /*<p>Hello - this is a paragraph from JSX.</p>
                <h2>Hello there - this is h2 from JSK.</h2>
                    <input type="text" placeholder="sky colour" value={$props.attributes.skyColour} onChange={updateSkyColour} />
                    <input type="text" placeholder="grass colour" 
            value={$props.attributes.grassColour} onChange={updateGrassColour} />*/
            )
        }
    
       
        
    
    

