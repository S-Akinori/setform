<x-app-layout>
    <form class="max-w-3xl m-auto" v-on:submit.prevent="addNewInputGroup">
        @csrf
        <div class="m-auto flex justify-center h-8">
            <div class="flex justify-around">
                <input type="text" placeholder="タイトル" v-model="newTitle" class="block rounded mx-3 border border-gray-400 focus:outline-none focus:ring-1 focus:border-indigo-400">
                <select name="" id="" v-model="selected" class="block mx-3 border border-gray-400 focus:outline-none focus:ring-1 focus:border-indigo-400">
                    <option value="text" selected>1行テキスト</option>
                    <option value="textarea">複数行テキスト</option>
                    <option value="checkbox">チェックボックス</option>
                    <option value="radio">ラジオボタン</option>
                    <option value="file">ファイル</option>
                    <option value="email">メールアドレス</option>
                </select>
                <button class="block mx-3 bg-blue-100 rounded-xl py-2 px-4 align-baseline flex items-center focus:outline-none"> ＋ 追加</button>
            </div>
        </div>
    </form>

    <div class="max-w-2xl m-auto">
        <input-group
            v-for="(inputGroup, index) in inputGroups"
            v-bind:key="inputGroup.id"
            v-bind:input-group="inputGroup"
            v-on:remove="onRemove(index)"
            v-on:remove-input="onRemoveInput($event, index)"
            v-on:toggle-editable="onToggleTitleEditable(index)"
            v-on:update="onUpdateTitle($event, index)"
            v-on:update-inputs="onUpdateInputs(inputs, index)"
            v-on:add-new-inputs="onAddNewInputs($event, index)"
        ></input-group>
    </div>

    <form action="{{route('form.store')}}" method="POST" v-on:submit="submitEvent" name="form">
        @csrf
        <input type="hidden" name="formats" value="" id="formats">
        <button type="submit" class="block py-2 px-3 ml-auto mr-3 rounded bg-yellow-400 hover:bg-yellow-200 duration-300">作成</button>
    </form>
</x-app-layout>