<template>
    <div>
        <div v-for="answer in answers" v-bind:key="answer.id" class="my-5">
            <p>回答日時：{{answer.created_at}}</p>
            <p>id : {{answer.id}}</p>
            <div>
                <div v-for="(item, index) in answer.answers" v-bind:key="index">
                    <div v-if="Array.isArray(item)">
                        【{{index}}】
                        <p v-for="(value, index) in item" v-bind:key="index">
                            {{value}}
                        </p>
                    </div>
                    <div v-else>
                        【{{index}}】 <br> {{item}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            answers: []
        }
    },
    methods: {
        getAnswers() {
            axios.get('/api/answers/' + this.$route.params.key)
            .then((res) => {
                console.log(res);
                for(var item of res.data) {
                    item.answers = JSON.parse(item.answers)
                }
                this.answers = res.data;
            })
        }
    },
    mounted() {
        this.getAnswers();
    }
}
</script>