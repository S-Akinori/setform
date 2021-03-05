require('./bootstrap');
import axios from 'axios';
import Vue from 'vue'
import InputGroup from './components/InputGroup.vue'

var app = new Vue({
    el: '#app',
    data: {
        newTitle: '',
        selected: 'text',
        inputGroups: [
            {
                id: 0,
                title: 'First Input Form',
                type: 'text',
                name: 'answer0',
                editable: false,
                required: true,
                inputs: [
                    {
                        id: 0,
                        label: 'ラベル0',
                        editable: false,
                    }
                ],
            },
            {
                id: 1,
                title: 'Second Input Form',
                type: 'checkbox',
                name: 'answer1[]',
                editable: false,
                required: true,
                inputs: [
                    {
                        id: 0,
                        label: 'ラベル0',
                        editable: false,
                    }
                ],
            },
            {
                id: 2,
                title: 'Third Input Form',
                type: 'radio',
                name: 'answer2',
                editable: false,
                required: true,
                inputs: [
                    {
                        id: 0,
                        label: 'ラベル0',
                        editable: false,
                    }
                ],
            },
            {
                id: 3,
                title: 'Text area',
                type: 'textarea',
                name: 'answer3',
                editable: false,
                required: true,
                inputs: [
                    {
                        id: 0,
                        label: 'ラベル0',
                        editable: false,
                    }
                ],
            },
            {
                id: 4,
                title: 'File',
                type: 'file',
                name: 'answer4',
                editable: false,
                required: true,
                inputs: [
                    {
                        id: 0,
                        label: 'ラベル0',
                        editable: false,
                    }
                ],
            }
        ],
        nextInputGroupId: 5
    },
    components: {
        InputGroup
    },
    methods: {
        addNewInputGroup: function () {
            var name = 'answer' + this.nextInputGroupId;

            if(this.selected == 'checkbox') {
                name += '[]';
            }

            this.inputGroups.push({
                id: this.nextInputGroupId,
                title: this.newTitle,
                type: this.selected,
                name: name,
                editable: false,
                inputs: [
                    {
                        id: 0,
                        label: 'ラベル0',
                        editable: false,
                    },
                ],
            })
            this.nextInputGroupId++
            this.newTitle = ''
            console.log(this.inputGroups);
        },
        onAddNewInputs(input, index) {
            this.inputGroups[index]['inputs'].push(input)
            console.log(this.inputGroups)
        },
        onRemove(index) {
            this.inputGroups.splice(index, 1)
            console.log('removed', this.inputGroups);
        },
        onRemoveInput(event, index) {
            this.inputGroups[index]['inputs'].splice(event, 1);
            console.log(this.inputGroups);
        },
        onUpdateTitle(event, index) {
            this.inputGroups[index]['title'] = event
            this.onToggleTitleEditable(index)
            console.log('updated InputGroup : ', this.inputGroups[index]);
        },
        onToggleTitleEditable(index) {
            this.inputGroups[index]['editable'] = !this.inputGroups[index]['editable']
            return this.inputGroups[index]
        },
        submitEvent: function() {
            var formatInput = document.getElementById('formats');
            console.log(formatInput)
            formatInput.setAttribute('value', JSON.stringify(this.inputGroups));
            return true;
            // axios.post('/form', this.inputGroups)
            // .then(function (response) {
            //     console.log('submitted', response)
            // })
            // .catch(function (error) {
            //     console.log('submit error', error)
            // })
            
        },
        onUpdateInputs() {
            this.inputGroups[index]["inputs"] = inputs;
            console.log('updated inputGroup : ', this.inputGroups[index]);
        }
    }
})