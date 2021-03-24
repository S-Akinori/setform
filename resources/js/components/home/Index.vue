<template>
<div class="lg:container mx-auto md:px-4">
    <div class="md:flex items-center justify-center">
        <img src="/storage/img/header.png" alt="header" class="w-full md:w-3/4 max-w-2xl">
        <div>
            <p class="font-bold text-2xl lg:text-3xl text-center md:text-left">
                登録不要<br>
                サクッとアンケート作成
            </p>

            <div class="flex justify-center md:justify-start">
                <router-link :to="{name: 'form.create'}" class="inline-block my-3 bg-indigo-300 py-3 px-5 rounded-full text-white font-bold focus:outline-none hover:bg-indigo-200 duration-300">今すぐ作成する</router-link>
            </div>
        </div>
    </div>

    <div class="feature my-10">
        <h2 class="font-bold text-3xl text-center bg-indigo-200 py-2 rounded-md">3つの特徴</h2>
        <div class="sm:grid grid-cols-3 gap-4 my-5 mx-5">
            <div class="mb-20">
                <h3 class="font-bold text-xl text-center">ユーザー登録不要</h3>
                <div class="my-3">
                    <p class="sm:h-28 mb-5 sm:mb-0">登録、ログインなどの手間が省け今すぐ始めることができます。</p>
                    <img src="/storage/img/feature.png" alt="feature" class="w-48 sm:w-3/4 sm:h-3/4 m-auto  rounded-full">
                </div>
            </div>
            <div class="mb-20">
                <h3 class="font-bold text-xl text-center">素早く作成</h3>
                <div class="my-3">
                    <p class="sm:h-28 mb-5 sm:mb-0">シンプルなデザインで、タイトルと入力タイプを決めるだけで作れます。</p>
                    <img src="/storage/img/feature1.png" alt="feature1" class="w-48 sm:w-3/4 sm:h-3/4 m-auto  rounded-full">
                </div>
            </div>
            <div class="mb-20">
                <h3 class="font-bold text-xl text-center">スプレッドシートで管理</h3>
                <div class="my-3">
                    <p class="sm:h-28 mb-5 sm:mb-0">回答結果はGoogleスプレッドシートで自動で管理できます。</p>
                    <img src="/storage/img/feature2.png" alt="feature2" class="w-48 sm:w-3/4 sm:h-3/4 m-auto  rounded-full">
                </div>
            </div>
        </div>
    </div>

    <div class="guide my-5">
        <h2 class="font-bold text-3xl text-center bg-indigo-200 py-2 rounded-md mb-5">作成方法</h2>
        <div class="mx-5">
            <div class="guide-1 my-5 p-3 max-w-2xl mx-auto border-2 border-gray-300">
                <h3 class="font-bold text-lg sm:text-xl sm:text-center mb-3">アンケート作成画面で入力画面を作成</h3>
                <div class="sm:flex items-center justify-center">
                    <img src="/storage/img/guide0.png" alt="guide0" class="w-full max-w-md">
                    <p class="mt-5 md:mt-0">
                        タイトルと入力タイプを追加します。<br>
                        説明など細かい設定もできます。
                    </p>
                </div>
            </div>
            <img src="/storage/img/arrow.png" alt="arrow" class="w-60 m-auto">

            <div class="guide-2 my-5 p-3 max-w-2xl mx-auto border-2 border-gray-300">
                <h3 class="font-bold text-lg sm:text-xl sm:text-center mb-3">IDを取得</h3>
                <div class="flex items-center justify-center">
                    <p>
                        フォーム作成後にIDが自動で生成されます。<br>
                        IDをURLに設定することでリンクを作ることができます。<br>
                        ＊URLは「https://setform.site/form/生成されたID」です。
                    </p>
                </div>
            </div>
            <img src="/storage/img/arrow.png" alt="arrow" class="w-60 m-auto">

            <div class="guide-3 my-5 p-3 max-w-2xl mx-auto border-2 border-gray-300">
                <h3 class="font-bold text-lg sm:text-xl sm:text-center mb-3">スプレッドシートにコード貼りつけ</h3>
                <div class="flex items-center justify-center">
                    <p>
                        <a href="https://gist.github.com/24820c0aa19343d37aa636d671128dc0.git" class="underline ">「こちら」</a>のコードをGoogleスプレッドシートのスクリプトエディタに貼り付けます。
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
        <router-link :to="{name: 'form.create'}" class="inline-block my-3 mx-auto m-auto bg-indigo-300 py-3 px-5 rounded-full text-white font-bold focus:outline-none hover:bg-indigo-200 duration-300">さっそく作成</router-link>
        </div>

    </div>
</div>
</template>

<script>
export default {
    
}
</script>