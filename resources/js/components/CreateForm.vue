<template>
    <div>
        <form class="max-w-3xl m-auto mb-5" v-on:submit.prevent="addNewInputGroup">
            <!-- @csrf -->
            <div class="m-auto flex justify-center h-8">
                <div class="flex justify-around">
                    <input type="text" placeholder="タイトル" v-model="newTitle" class="block w-80 rounded mx-3 border border-gray-400 focus:outline-none focus:ring-1 focus:border-indigo-400">
                    <select name="" id="" v-model="selected" class="block mx-3 border border-gray-400 focus:outline-none focus:ring-1 focus:border-indigo-400">
                        <option value="text" selected>1行テキスト</option>
                        <option value="textarea">複数行テキスト</option>
                        <option value="checkbox">チェックボックス</option>
                        <option value="radio">ラジオボタン</option>
                        <option value="file">ファイル</option>
                        <option value="email">メールアドレス</option>
                    </select>
                    <button class="block mx-3 bg-blue-100 rounded-xl py-2 px-4 align-baseline flex items-center focus:outline-none hover:bg-blue-50 duration-300"> ＋ 追加</button>
                </div>
            </div>
        </form>

        <div class="max-w-2xl m-auto bg-white rounded-lg p-5">
            <input-group
                v-for="(inputGroup, index) in inputGroups"
                v-bind:key="inputGroup.id"
                v-bind:input-group="inputGroup"
                v-on:remove="onRemove(index)"
                v-on:remove-input="onRemoveInput($event, index)"
                v-on:toggle-editable="onToggleTitleEditable(index)"
                v-on:input="onUpdateValue($event, index)"
                v-on:update-inputs="onUpdateInputs(inputs, index)"
                v-on:add-new-inputs="onAddNewInputs($event, index)"
            ></input-group>
        </div>

        <form v-on:submit.prevent="create">
            <!-- @csrf -->
            <button type="submit" class="block py-2 px-3 ml-auto mr-3 rounded bg-yellow-400 hover:bg-yellow-200 duration-300" :disabled="isActive">作成</button>
        </form>
    </div>
</template>

<script>
import InputGroup from './InputGroup.vue'

export default {
    components: {
        InputGroup,
    },
    data: function() {
        return {
            isActive: false,
            newTitle: '',
            selected: 'text',
            inputGroups: [
                {
                    id: 0,
                    title: 'Text',
                    type: 'text',
                    name: 'answer0',
                    editable: false,
                    validation: {required: true},
                    description: '',
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
                    title: 'Check',
                    type: 'checkbox',
                    name: 'answer1[]',
                    editable: false,
                    validation: {required: true},
                    description: '',
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
                    title: 'Radio',
                    type: 'radio',
                    name: 'answer2',
                    editable: false,
                    validation: {required: true},
                    description: '',
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
                    validation: {required: true},
                    description: '',
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
                    validation: {required: true},
                    description: '',
                    inputs: [
                        {
                            id: 0,
                            label: 'ラベル0',
                            editable: false,
                        }
                    ],
                },
            ],
            nextInputGroupId: 5
        }
    },
    methods: {
        addNewInputGroup: function () {
            var name = 'answer' + this.nextInputGroupId;

            // if checkbox, name attributes should be an array
            if(this.selected == 'checkbox') {
                name += '[]';
            }

            this.inputGroups.push({
                id: this.nextInputGroupId,
                title: this.newTitle,
                type: this.selected,
                name: name,
                editable: false,
                validation: {required: true},
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
        onUpdateValue(event, index) {
            console.log(event);
            console.log(index)
            if(event.name.indexOf('.') > -1) {
                var name = event.name.split('.')
                console.log(name)
                var item = this.inputGroups[index][name[0]]
                item[event.index][name[1]] = event.value
            } else {
                this.inputGroups[index][event.name] = event.value
            }
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
        create: function() {
            this.isActive = true;
            var inputGroups = this.inputGroups;

            for(var key in inputGroups) {
                inputGroups[key]['id'] = key
                var inputs = inputGroups[key]['inputs']
                for(var key1 in inputs) {
                    inputs[key1]['id'] = key1                    
                }
            }

            console.log(inputGroups);

            axios.post('/api/form', {formats: inputGroups})
            .then((response) => {
                console.log('submitted', response)
                console.log(response['data']['form_key'])
                this.$router.push('/form/info/' + response['data']['form_key'] + '/' + response['data']['answer_key'])
            })
            .catch((error) => {
                console.log('submit error', error)
            })

            this.isActive = false;
            
        },
        onUpdateInputs() {
            this.inputGroups[index]["inputs"] = inputs;
            console.log('updated inputGroup : ', this.inputGroups[index]);
        }
    }
}
</script>