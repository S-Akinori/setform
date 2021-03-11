<template>
    <div class="mx-3">
        <div class="my-5">
            <h2 class="font-bold">以下は重要な情報なので必ず保存してください。</h2>
            <p>キー1 （フォーム用）: {{formKey}}</p>
            <p>キー2 （回答確認用）: {{answerKey}}</p>
        </div>

        <div class="my-5">
            <h2 class="font-bold">作成したフォームURLは以下になります。</h2>
            <a v-bind:href="'https://setform.site/form/' + formKey" class="underline">https://setform.site/form/{{formKey}}</a>
            <p>＊「https://setform.site/form/キー1」という形になっています。</p>
        </div>

        <div class="my-5">
            <h2 class="font-bold">回答データをGoogleスプレッドシートに保存する方法</h2>
            <ol class="list-decimal list-inside ml-5">
                <li class="my-5">新しくスプレッドシートを作成する</li>
                <li class="my-5">
                    「ツール」から「スクリプトエディタ」を開く
                    <img src="/storage/img/capture.png" alt="" class="max-w-xl">
                </li>
                <li class="my-5">以下のURLからコードをコピーして「スクリプトエディタ」に貼り付ける<br>
                    <a href="https://gist.github.com/S-Akinori/24820c0aa19343d37aa636d671128dc0" class="underline">https://gist.github.com/S-Akinori/24820c0aa19343d37aa636d671128dc0</a> <br>
                    ＊「ここは自身のスプレッドシートの文字列」、「キー2」、「シート名」はご自身で入力してください
                </li>
                <li class="my-5">
                    「実行」を押すとデータが書き込まれます 
                    <img src="/storage/img/capture1.png" alt="" class="w-3/4">
                </li>
            </ol>
        </div>
    </div>
</template>

<script>
export default {
    data: function(){
        return {
            formKey: this.$route.params.formKey,
            answerKey: this.$route.params.answerKey,
        }
    }
}
</script>