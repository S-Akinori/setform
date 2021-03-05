<template>
    <div class="my-5 flex">
        <div class="w-full">
            <div class="w-full">
                <h2 v-if="!inputGroup.editable" v-on:click="toggleTitleEditable" class="text-xl text-center py-3 w-full rounded-lg bg-blue-100 focus:bg-white">{{inputGroup.title}}<span v-if="inputGroup.required" class="text-red-500"> *</span></h2>
                <input v-else type="text" class="text-xl text-center py-3 w-full rounded-lg" ref="inputTitle" placeholder="タイトル" v-on:blur="updateValue" :value="inputGroup.title">

                <!-- checkbox and radio button -->
                <div v-if="inputGroup.type == 'checkbox' || inputGroup.type == 'radio' " class="flex justify-center">
                    <div>
                        <div v-for="(input, index) in inputGroup.inputs" v-bind:key="input.id" class="my-3 flex items-center">
                            <custom-input v-bind:id="'input' + inputGroup.id + '_' + input.id" :type="inputGroup.type" :name='inputGroup.name'></custom-input>
                            <input type="text" :value="input.label" v-on:blur="updateLabel($event.target.value, index)" placeholder="ラベル" class="block mx-1 bg-gray-100 focus:bg-white">

                            <button class="bg-red-200 rounded-full h-5 w-5 mx-2 flex items-center justify-center" v-on:click="RemoveInput(index)">x</button>
                        </div>
                    </div>
                </div>

                <!-- text -->
                <div v-else-if="inputGroup.type !== 'textarea'" class="flex justify-center">
                    <div class="w-3/4">
                        <div v-for="(input, index) in inputGroup.inputs" v-bind:key="input.id" class="my-3">
                            <input type="text" :value="input.label" v-on:blur="updateLabel($event.target.value, index)" placeholder="ラベル" class="block bg-gray-100 focus:bg-white">
                            <custom-input v-bind:id="'input' + inputGroup.id + '_' + input.id" :type="inputGroup.type" :name='inputGroup.name' class="my-3 py-1 w-full"></custom-input>
                        </div>
                    </div>
                </div>

                <!-- textarea -->
                <div v-else class="flex justify-center">
                    <div class="w-3/4">
                        <div v-for="(input, index) in inputGroup.inputs" v-bind:key="input.id" class="my-3">
                            <input type="text" :value="input.label" v-on:blur="updateLabel($event.target.value, index)" placeholder="ラベル" class="block bg-gray-100 focus:bg-white">
                            <custom-textarea v-bind:id="'input' + inputGroup.id + '_' + input.id" :type="inputGroup.type" :name='inputGroup.name' class="my-3 py-1 w-full"></custom-textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ml-5 w-24">
            <div class="flex my-1">
                <button class="bg-green-200 rounded-full h-8 w-8 mx-1" v-on:click="AddNewInput" v-if="inputGroup.type == 'checkbox' || inputGroup.type == 'radio'">+</button>
                <button class="bg-red-200 rounded-full h-8 w-8 mx-1" v-on:click="$emit('remove')">x</button>
            </div>
            <button class="bg-pink-200 rounded-full h-8 w-8 mx-1" v-on:click="toggleRequired">*</button>
        </div>
    </div>
</template>

<script>
import CustomTextarea from './CustomTextarea.vue'
import CustomInput from './CustomInput.vue'
export default {

    props: ['inputGroup'],

    data: function() {
        return {
            // inputs: [
            //     {
            //         id: 0,
            //         label: 'ラベル0',
            //         editable: false,
            //     }
            // ],
            nextInputId: 1
        }
    },
    components: {
        CustomInput,
        CustomTextarea,
    },
    methods: {
        AddNewInput: function() {
            var input = {
                id: this.nextInputId,
                label: 'ラベル' + this.nextInputId,
                editable: false,
            }
            this.$emit('add-new-inputs', input)
            this.nextInputId++
        },

        RemoveInput: function(index) {
            this.$emit('remove-input', index)
        },

        updateValue: function(e) {
            this.$emit('update', e.target.value)
        },

        toggleTitleEditable: function() {
            var inputGroup = this.$emit('toggle-editable')
            this.$nextTick(function() {
                if(inputGroup['inputGroup']['editable']) {
                    this.$refs.inputTitle.focus()
                }
            });
        },

        toggleLabelEditable: function(index) {
            var input = this.inputGroup.inputs[index];
            input['editable'] = !input['editable']
            this.$nextTick(function() {
                if(input['editable']) {
                    this.$refs.inputLabel[index].focus()
                }
            })
        },

        updateLabel: function(value, index) {
            var input = this.inputGroup.inputs[index]
            input['label'] = value
            console.log('updated inputs : ', this.inputGroup);
        },

        updateInputs: function(inputs, index) {
            this.$emit('update-inputs', inputs, index)
        },

        toggleRequired: function() {
            this.inputGroup['required'] = !this.inputGroup['required'];
        }
    }
}
</script>