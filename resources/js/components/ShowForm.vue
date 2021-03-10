<template>
    <form enctype="multipart/form-data" @submit.prevent="postAnswers">
        <div class="max-w-2xl m-auto bg-white rounded-lg p-5">
            <p v-if="errors.length" class="text-red-500">入力エラーがあります</p>
            <show-input-group
                v-for="(inputGroup, index) in inputGroups"
                v-bind:key="inputGroup.id"
                v-bind:input-group="inputGroup"
                v-bind:errors="errors[index]"
                v-model="values[index]"
            ></show-input-group>
        </div>

        <button type="submit" class="block py-2 px-3 ml-auto mr-3 rounded bg-yellow-400 hover:bg-yellow-200 duration-300" :disabled="isActive">送信</button>
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
                console.log(res);
                this.inputGroups = JSON.parse(res.data.formats);
                console.log(this.inputGroups);

                this.id = res.data.id;
                this.answer = Array(this.inputGroups.length)
                for(var inputGroup of this.inputGroups) {
                    // if(inputGroup.type == 'checkbox') {
                    //     this.values[inputGroup.id] = ['']
                    // } else {
                    //     this.values[inputGroup.id] = ''
                    // }
                    this.values[inputGroup.id] = null
                    this.validation[inputGroup.id] = inputGroup.validation
                }
            })
        },
        postAnswers: function() {
            this.isActive = true;

            var answers = {}
            
            for(var key in this.inputGroups) {
                this.errors[key] = null
            }

            for(var key in this.values) {
                if(this.validation[key]['required']) {
                    if(this.values[key] == null || this.values[key].length == 0) {
                        // use $set to output errors
                        this.$set(this.errors, key, {required: '必須項目です'})
                        // this.errors[key] = {required: '必須項目です'}
                    }
                }
                var title = this.inputGroups[key]['title']
                answers[title] = this.values[key]
            }


            for(var key in this.errors) {
                if(this.errors[key] !== null) {
                    console.log('errors : ', this.errors);
                    return false
                }
            }

            axios.post('/api/answers', {
                answers: answers,
                form_id: this.id,
            })
            .then((res) => {
                console.log('submitted', res)
                this.$router.push('/form/thankyou');
            })
            .catch((error) => {
                console.log('submit error', error)
            })

            this.isActive = false;

        }
    },
    mounted() {
        this.getInputGroup();
    }
}
</script>