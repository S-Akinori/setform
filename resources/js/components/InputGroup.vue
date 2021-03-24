<template>
<div class="my-5 flex justify-center">
    <div class="w-full">
        <div>
            <h2 v-if="!inputGroup.editable" @click="toggleTitleEditable()" class="text-xl text-center py-3 w-full rounded-lg bg-blue-100">{{inputGroup.title}}<span v-if="inputGroup.validation.required" class="text-red-500"> *</span></h2>
            <input v-else type="text" class="text-xl text-center py-3 w-full rounded-lg" ref="inputTitle" placeholder="タイトル" @input="updateValue($event, 'title')" @blur="toggleTitleEditable()" :value="inputGroup.title">
        </div>

        <!-- checkbox and radio button -->
        <div v-if="inputGroup.type == 'checkbox' || inputGroup.type == 'radio' " class="flex justify-center">
            <div class="w-11/12">
                <div v-for="(input, index) in inputGroup.inputs" v-bind:key="input.id" class="my-3 flex items-center">
                    <input :id="'input' + inputGroup.id + '_' + input.id" :type="inputGroup.type" :name='inputGroup.name' >

                    <input type="text" :value="input.label" @blur="updateValue($event, `inputs.${index}.label`)" placeholder="ラベル" class="block mx-1 bg-gray-100 focus:bg-white">

                    <button class="bg-red-200 rounded-full h-5 w-5 mx-2 flex items-center justify-center hover:bg-red-100" v-on:click="removeInput(index)">x</button>
                </div>
                <textarea name="" id="" rows="2" placeholder="説明" class="w-full block border border-gray-300 rounded" :value="inputGroup.description" @blur="updateValue($event, 'description')"></textarea>
            </div>
        </div>

        <!-- textarea -->
        <div v-else-if="inputGroup.type == 'textarea'" class="flex justify-center">
            <div class="w-11/12">
                <div v-for="(input, index) in inputGroup.inputs" v-bind:key="input.id" class="my-3">
                    <input type="text" :value="input.label" @blur="updateValue($event, `inputs.${index}.label`)"  placeholder="ラベル" class="block bg-gray-100 focus:bg-white">
                    <textarea :id="'input' + inputGroup.id + '_' + input.id" :name='inputGroup.name' rows="5"  class="my-3 py-1 w-full block border border-gray-300 rounded"></textarea>
                </div>
                <textarea name="" id="" rows="2" placeholder="説明" class="w-full block border border-gray-300 rounded" :value="inputGroup.description" @blur="updateValue($event, 'description')"></textarea>
            </div>
        </div>

        <!-- text -->
        <div v-else class="flex justify-center">
            <div class="w-11/12">
                <div v-for="(input, index) in inputGroup.inputs" v-bind:key="input.id" class="my-3">
                    <input type="text" :value="input.label" @blur="updateValue($event, `inputs.${index}.label`)" placeholder="ラベル" class="block bg-gray-100 focus:bg-white">
                    <input :id="'input' + inputGroup.id + '_' + input.id" :name="inputGroup.name" :type="inputGroup.type" class="my-3 py-1 w-full border border-gray-300 rounded" />
                </div>
                <textarea name="" id="" rows="2" placeholder="説明" class="w-full block border border-gray-300 rounded" :value="inputGroup.description" @blur="updateValue($event, 'description')"></textarea>
            </div>
        </div>
    </div>

    <div class="ml-5 w-24">
        <div class="flex my-1">
            <button class="bg-green-200 rounded-full h-8 w-8 mx-1 hover:bg-green-100" v-on:click="AddNewInput" v-if="inputGroup.type == 'checkbox' || inputGroup.type == 'radio'">+</button>
            <button class="bg-red-200 rounded-full h-8 w-8 mx-1 hover:bg-red-100" v-on:click="removeInputGroup">x</button>
        </div>
        <button class="bg-pink-200 rounded-full h-8 w-8 mx-1 my-1 hover:bg-pink-100" v-on:click="toggleRequired">*</button>
        <button class="bg-pink-200 rounded-full h-8 w-8 mx-1 my-1 hover:bg-pink-100" v-on:click="toggleSettings"><i class="fas fa-cog"></i></button>
    </div>
</div>
</template>

<script>
import CustomTextarea from './CustomTextarea.vue'
import CustomInput from './CustomInput.vue'
import CustomRadio from './CustomRadio.vue'
import CustomCheck from './CustomCheck.vue'

export default {

    props: ['inputGroup'],

    data: function() {
        return {
            nextInputId: 1
        }
    },
    components: {
        CustomInput,
        CustomTextarea,
        CustomRadio,
        CustomCheck
    },
    methods: {
        AddNewInput: function() {
            var input = {
                id: this.nextInputId,
                label: '',
                editable: false,
            }
            this.$emit('add-new-inputs', input);
            this.nextInputId++
        },

        removeInput: function(index) {
            this.$emit('remove', {id: this.inputGroup.id, key: `inputs.${index}`})
        },

        updateValue: function(e, key) {
            this.$emit('input', {id: this.inputGroup.id, value: e.target.value, key: key})
        },

        toggleTitleEditable: function() {
            var inputGroup = this.$emit('toggle-editable')
            this.$nextTick(function() {
                if(inputGroup['inputGroup']['editable']) {
                    this.$refs.inputTitle.focus()
                }
            });
        },

        removeInputGroup: function() {
            this.$emit('remove', {id: this.inputGroup.id, key: ''});
        },

        toggleRequired: function() {
            this.inputGroup['validation']['required'] = !this.inputGroup['validation']['required'];
        },

        toggleSettings() {
            this.$emit('toggle-settings');
        },
        
    }
}
</script>