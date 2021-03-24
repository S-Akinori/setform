<template>
    <div class="container px-5 mx-auto">
        <div v-if="message" class="bg-green-100 p-3 my-3">{{message}}</div>
        <h2>項目を埋めて削除ボタンを押してください。</h2>
        <ul class="list-disc list-inside max-w-xl p-5 m-5 bg-red-300">
            <li>回答結果も含め全てのデータが消去されます。</li>
            <li>削除後にデータを元に戻すことはできません。</li>
        </ul>
        <form @submit.prevent="deleteForm()" class="max-w-xl" ref="form">
            <div>
                <label for="formKey">ID1 (フォーム用)</label>
                <input type="text" id="formKey" name="form_key" class="block w-full my-3 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400" v-model="formKey">
            </div>
            <div>
                <label for="answerKey">ID2 (回答確認用)</label>
                <input type="text" id="answerKey" name="answer_key" class="block w-full my-3 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400" v-model="answerKey">
            </div>

            <div v-if="error" class="text-red-400">{{error}}</div>

            <button ref="submitButton" class="block ml-auto px-2 py-1 bg-red-300 hover:bg-red-200 duration-300" :disabled="!isActive">削除</button>
        </form>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            formKey: '',
            answerKey: '',
            error: '',
            message: '',
            isActive: true
        }
    },
    methods: {
        deleteForm: function() {
            if(!this.isActive) return;

            var activeButtonColor = 'bg-red-300';
            var inactiveButtonColor = 'bg-red-200';
            var submitButton = this.$refs.submitButton;

            this.isActive = false;
            submitButton.classList.remove(activeButtonColor);
            submitButton.classList.add(inactiveButtonColor);

                axios.delete('/api/form/destory', {
                    data: {
                        form_key: this.formKey,
                        answer_key: this.answerKey
                    }
                })
                .then((res) => {
                    console.log('success');
                    console.log(res);
                    this.message = '削除しました。';
                    this.isActive = true;
                    submitButton.classList.add(activeButtonColor);
                    submitButton.classList.remove(inactiveButtonColor);
                })
                .catch((error) => {
                    console.log('failed');
                    console.log(error);
                    this.error = 'ID1またはID2が間違っています';
                    this.isActive = true;
                    submitButton.classList.add(activeButtonColor);
                    submitButton.classList.remove(inactiveButtonColor);
                })

        }
        
    }
}
</script>