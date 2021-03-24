<template>
    <form enctype="multipart/form-data" @submit.prevent="postAnswers">
        <div class="max-w-2xl m-auto bg-white rounded-lg p-5">
            <p v-if="errors.length" class="text-red-500">入力エラーがあります</p>
            <div v-for="(inputGroup, index) in inputGroups" v-bind:key="inputGroup.id">
                <show-input-group
                    v-if="inputGroup.type == 'file'"
                    v-bind:input-group="inputGroup"
                    v-bind:errors="errors[index]"
                    v-on:input="onUpdateValue($event, index)"
                ></show-input-group>

                <show-input-group
                    v-else
                    v-bind:input-group="inputGroup"
                    v-bind:errors="errors[index]"
                    v-model="values[index]"
                ></show-input-group>
            </div>
            <button type="submit" ref="submit" class="block py-2 px-3 ml-auto mr-3 rounded bg-yellow-400 hover:bg-yellow-200 duration-300" :disabled="isActive">送信</button>
        </div>
    </form>
</template>

<script>
import ShowInputGroup from './ShowInputGroup.vue'
export default {
    data: function() {
        return {
            values: [],
            inputGroups: [],
            errors: [],
            validation: [],
            form_id: '',
            isActive: false,
        }
    },
    components: {
        ShowInputGroup
    },
    methods: {
        getInputGroup() {
            axios.get('/api/form/' + this.$route.params.key)
            .then((res) => {
                // console.log(res)
                // console.log('response: ', res);
                this.inputGroups = JSON.parse(res.data.formats);
                // console.log(this.inputGroups);

                this.form_id = res.data.id;
                this.answer = Array(this.inputGroups.length)
                for(var inputGroup of this.inputGroups) {
                    this.values[inputGroup.id] = null
                    this.validation[inputGroup.id] = inputGroup.validation
                }
            })
            .catch((error) => {
                console.log('failed');
                this.$router.push('/error')
            })
        },
        onUpdateValue(event, index) {
            this.values[index] = event;
        },
        postAnswers: function() {
            //** avoid double click
            var activeButtonColor = 'bg-yellow-400';
            var inactiveButtonColor = 'bg-yellow-200';
            var submitButton = this.$refs.submit;
            
            this.isActive = true;
            submitButton.classList.remove(activeButtonColor);
            submitButton.classList.add(inactiveButtonColor);

            // inital settings
            var answers = {}
            for(var key in this.inputGroups) {
                this.errors[key] = null
            }

            // validation
            for(var key in this.values) {
                if(this.validation[key]['required']) {
                    if(this.values[key] == null || this.values[key].length == 0) {
                        // use $set to output errors
                        this.$set(this.errors, key, {required: '必須項目です'})
                        // this.errors[key] = {required: '必須項目です'}
                    }
                }
                if(this.values[key] !== null) {
                    if(this.validation[key]['max']) {
                        if(this.values[key].length > this.validation[key]['max']) {
                            this.$set(this.errors, key, {max: `${this.validation[key]['max']}文字以内で入力してください`})
                        }
                    }
                    if(this.validation[key]['min']) {
                        if(this.values[key].length < this.validation[key]['min']) {
                            this.$set(this.errors, key, {min: `${this.validation[key]['min']}文字以上で入力してください`})
                        }
                    }
                    if(this.validation[key]['type']) {
                        if(this.validation[key]['type'] == 'image') {
                            var isImg = this.isImage(this.values[key].name);
                            if(!isImg) {
                                this.$set(this.errors, key, {type: '画像ファイルを選択してください'})
                            }
                        } else if(this.validation[key]['type'] == 'video') {
                            var isVdo = this.isVideo(this.values[key].name);
                            if(!isVdo) {
                                this.$set(this.errors, key, {type: '動画ファイルを選択してください'})
                            }
                        }
                    }
                    if(this.validation[key]['confirmation']) {
                        var keys = Object.keys(this.values[key]);
                        console.log(keys)
                        console.log(this.values[key][keys[0]])
                        console.log(this.values[key][keys[1]])
                        if(this.values[key][keys[0]] !== this.values[key][keys[1]]) {
                            this.$set(this.errors, key, {confirmation: '同じ値を入力してください。'})
                        } else { //後でこの操作は行いたい <-ここのforはあくまでvalidationだけの操作にしたい
                            this.values.splice(key, 1, this.values[key][keys[0]]);
                        }
                    }
                }
            }

            for(var key in this.errors) {
                if(this.errors[key] !== null) {
                    console.log('errors : ', this.errors);
                    this.$data.isActive = false;
                    submitButton.classList.add(activeButtonColor);
                    submitButton.classList.remove(inactiveButtonColor);
                    return false
                }
            }

            // save files
            var fileIds = [];
            var files;
            var fileData = new FormData();

            for(var key in this.values) {
                if(this.values[key] instanceof File) {
                    var id = this.inputGroups[key]['id'];
                    fileIds.push(id);
                    fileData.append('files[]', this.values[key])
                    fileData.append('ids[]', id)
                }
            }
            fileData.append('form_key', this.$route.params.key)

            axios.post('/api/answers_files', fileData)
            .then((res) => {
                console.log('success: ', res)
                files = res.data;

                // set answers
                for(var key in this.values) {
                    var title = this.inputGroups[key]['title'];
                    if(this.values[key] instanceof File) {
                        answers[title] = files[key];
                    } else {
                        answers[title] = this.values[key];
                    }
                }
                console.log(answers);

                // submit data
                axios.post('/api/answers', {
                    answers: answers,
                    form_id: this.form_id,
                })
                .then((res) => {
                    console.log('submitted', res)
                    this.$router.push('/form/thankyou');
                })
                .catch((error) => {
                    console.log('submit error', error)
                    this.$data.isActive = false;
                    submitButton.classList.add(activeButtonColor);
                    submitButton.classList.remove(inactiveButtonColor);
                })
            })
            .catch((error) => {
                console.log('error: ', error);
                this.$data.isActive = false;
                submitButton.classList.add(activeButtonColor);
                submitButton.classList.remove(inactiveButtonColor);
            });

        },
        isImage: function(fileName) {
            var ext = this.getExtension(fileName);
            ext = ext.toLowerCase();
            switch(ext) {
                case 'jpg':
                case 'gif':
                case 'bmp':
                case 'png':
                    return true;
            }
            return false;
        },
        isVideo: function(fileName) {
            var ext = this.getExtension(fileName);
            ext = ext.toLowerCase();
            switch(ext) {
                case 'm4v':
                case 'avi':
                case 'mpg':
                case 'mp4':
                    return true;
            }
            return false;
        },
        getExtension(fileName) {
            var parts = fileName.split('.');
            return parts[parts.length - 1];
        }
    },
    mounted() {
        this.getInputGroup();
    }
}
</script>