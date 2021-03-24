<template>
<div>
    <div class="fixed bottom-0 hidden bg-yellow-200 w-full h-24 overflow-y-scroll p-3 md:left-5 md:top-20 md:h-60 md:w-80 md:mx-5" ref="settings" :setting="setting">
        <div v-if="setting" class="w-3/4 mx-auto md:w-full">
            <div class="flex justify-between">
                <p>{{setting.title}}</p>
                <button @click="onToggleSettings(-1)" class="px-1 rounded bg-red-200 hover:bg-red-100">閉じる</button> 
            </div>
            <form @submit.prevent="addValidation()">
                <select v-model="selectedValidation">
                    <option v-for="(validation, index) in validations" v-bind:key="index" :value="index">{{validation}}</option>
                </select>
                <button type="submit">追加</button>
            </form>
            <ul>
                <li v-for="(validation, index) in setting.validation" v-bind:key="index" class="my-2">
                    <div class="flex">
                        <p v-if="typeof validation == 'boolean' ">{{validations[index]}} : {{validation}}</p>
                        <div v-else class="flex">
                            <label :for="index">{{validations[index]}} :</label> <input type="text" :id="index" :value="validation" @blur="editValidation($event.target.value, index)" class="w-16 ml-2 bg-transparent focus:bg-white" />
                        </div>
                        <button class="ml-auto mr-12 px-2 bg-red-200 rounded-full hover:bg-red-100" @click="deleteValidation(index, validation)">x</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="md:max-w-2xl md:mx-auto" ref="formContent">
        <form class="block w-full max-w-3xl mx-auto mb-5 px-1 md:px-5" v-on:submit.prevent="addNewInputGroup">
            <div class="m-auto">
                <div class="flex justify-center items-end">
                    <div class="md:grid md:grid-cols-3 gap-3 mx-3 w-3/4">
                        <input type="text" placeholder="タイトル" v-model="newTitle" class="w-full block col-span-2 my-3 py-1 md:my-0 max-w-lg rounded border border-gray-400 focus:outline-none focus:ring-1 focus:border-indigo-400">
                        <select name="" id="" v-model="selected" class="w-full block py-1 border border-gray-400 focus:outline-none focus:ring-1 focus:border-indigo-400">
                            <option value="text" selected>1行テキスト</option>
                            <option value="textarea">複数行テキスト</option>
                            <option value="checkbox">チェックボックス</option>
                            <option value="radio">ラジオボタン</option>
                            <option value="file">ファイル</option>
                            <option value="email">メールアドレス</option>
                        </select>
                    </div>
                    <button class="block w-16 bg-blue-100 rounded-xl py-2 px-2 align-baseline flex items-center justify-center focus:outline-none hover:bg-blue-50 duration-300 text-sm">追加</button>
                </div>
            </div>
        </form>

        <div class="w-full bg-white rounded-lg p-5">
            <input-group
                v-for="(inputGroup, index) in inputGroups"
                v-bind:key="inputGroup.id"
                v-bind:input-group="inputGroup"
                v-on:remove="onRemove(inputGroups, $event)"
                v-on:toggle-editable="onToggleTitleEditable(index)"
                v-on:input="onUpdate(inputGroups, $event)"
                v-on:add-new-inputs="onAddNewInputs($event, index)"
                v-on:toggle-settings="onToggleSettings(index)"
            ></input-group>
        </div>

        <form v-on:submit.prevent="create" class="my-3">
            <button type="submit" ref="submit" class="block py-2 px-3 ml-auto mr-3 rounded bg-yellow-400 hover:bg-yellow-200 duration-300" :disabled="isActive">作成</button>
        </form>
    </div>
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
            inputGroups: [],
            file: '',
            setting: {},
            validations: {
                required: '必須',
                max: '最大文字数',
                min: '最小文字数',
                type: 'ファイルの種類',
                confirmation: '入力確認'
            },
            selectedValidation: '',
            nextInputGroupId: 0,
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
                description: '',
                validation: {
                    required: true,
                },
                inputs: [
                    {
                        id: 0,
                        label: '',
                        editable: false,
                    },
                ],
            });
            this.nextInputGroupId++;
            this.newTitle = '';
        },
        onAddNewInputs(input, index) {
            this.inputGroups[index]['inputs'].push(input)
        },
        onUpdate: function(object, data) {
            var index = this.getIndex(this.inputGroups, data.id);
            if(data.key.indexOf('.') > -1 ) {
                var keys = data.key.split('.');
                object = object[index];
                var length = keys.length
                for(var i = 0 ; i < length - 1 ; i++) {
                    object = object[keys[i]];
                }
                
                this.$set(object, keys[length - 1], data.value);

            } else {
                this.$set(object[index], data.key, data.value);
            }
        },
        onRemove: function(object, option) {
            var index = this.getIndex(object, option.id);
            if(option.key.indexOf('.') > -1) {
                var keys = option.key.split('.');
                object = object[index];
                for(var i = 0 ; i < keys.length - 1 ; i++) {
                    object = object[keys[i]];
                }
                object.splice(keys[keys.length - 1], 1);

            } else {
                object.splice(index, 1);
            }
        },
        onToggleTitleEditable(index) {
            this.inputGroups[index]['editable'] = !this.inputGroups[index]['editable']
            return this.inputGroups[index]
        },
        create: function() {
            var activeButtonColor = 'bg-yellow-400';
            var inactiveButtonColor = 'bg-yellow-200';
            var submitButton = this.$refs.submit;
            var inputGroups = this.inputGroups;

            this.isActive = true;
            submitButton.classList.remove(activeButtonColor);
            submitButton.classList.add(inactiveButtonColor);

            axios.post('/api/form', {formats: inputGroups})
            .then((response) => {
                console.log('submitted', response)
                console.log(response['data']['form_key'])
                this.$router.push('/form/info/' + response['data']['form_key'] + '/' + response['data']['answer_key'])
            })
            .catch((error) => {
                console.log('submit error', error)
                this.$data.isActive = false;
                submitButton.classList.add(activeButtonColor);
                submitButton.classList.remove(inactiveButtonColor);
            })
        },
        onToggleSettings(index) {
            var element = this.$refs.settings;
            var formContent = this.$refs.formContent;
            var className = ('hidden');
            var hasHiddenClass = element.classList.contains(className);

            if(index < 0) {
                element.classList.add(className);
                formContent.classList.add('md:mx-auto');
                formContent.classList.remove('md:max-w-md', 'md:ml-auto', 'lg:mr-16', 'lg:max-w-xl', 'xl:mr-36');
                return false;
            }

            if(!hasHiddenClass && this.setting['id'] == this.inputGroups[index]['id']) {
                element.classList.add(className);
                formContent.classList.add('md:mx-auto', 'md:max-w-2xl');
                formContent.classList.remove('md:max-w-md', 'md:ml-auto', 'lg:mr-16', 'lg:max-w-xl', 'xl:mr-36');
            } else {
                this.setting = this.inputGroups[index];
                element.classList.remove(className);
                formContent.classList.remove('md:mx-auto', 'md:max-w-2xl');
                formContent.classList.add('md:max-w-md', 'md:ml-auto', 'lg:mr-16', 'lg:max-w-xl', 'xl:mr-36');
            }
        },
        addValidation: function() {
            var validation = this.selectedValidation;

            if(validation == '') {
                return
            }

            if(validation in this.setting.validation) {
                console.log('already exists');
            } else {
                if(validation == 'required' || validation == 'confirmation') {
                    this.$set(this.setting.validation, validation, true);
                } else if(validation == 'max' || validation == 'min') {
                    this.$set(this.setting.validation, validation, '10');
                } else if(validation == 'type') {
                    this.$set(this.setting.validation, validation, 'image');
                }

                var index = this.getIndex(this.inputGroups, this.setting.id);
                this.$set(this.inputGroups[index], 'validation', this.setting.validation);
                if(validation == 'confirmation') {
                    var input = {
                        id: 'confirmation',
                        label: '確認',
                        editable: false,
                    }
                    this.onAddNewInputs(input, index);
                }
            }
        },
        editValidation: function(value, key) {
            if(key == 'max' || key == 'min') {
                var regex=/^[0-9]+$/;
                if(value.match(regex)) {
                    this.$data.setting.validation[key] = Number(value);
                } else {
                    alert('文字数は数字で入力してください');
                    return;
                }

            } else if(key == 'type') {
                if(value == 'image' || value == 'video' ) {
                    this.setting.key = value
                } else {
                    alert("ファイルの種類は'image'か'video'で入力してください");
                    return;
                }
            }

            var index = this.getIndex(this.inputGroups, this.setting.id)
            this.inputGroups[index]['validation'] = this.setting.validation;
        },
        deleteValidation: function(key, value) {
            this.$delete(this.setting.validation, key);
            var index = this.getIndex(this.inputGroups, this.setting.id);
            this.inputGroups[index]['validation'] = this.setting.validation;
            if(key == 'confirmation') {
                var inputs = this.inputGroups[index]['inputs'];
                for(var i = 0 ; i < inputs.length ; i++) {
                    if(inputs[i]['id'] == 'confirmation') {
                        inputs.splice(i, 1);
                    }
                }
            }
        },
        getIndex: function(object, id) {
            for(var i = 0 ; i < object.length ; i++) {
                if(object[i]['id'] == id) {
                    return i;
                }
            }
            return false;
        }
    }
}
</script>