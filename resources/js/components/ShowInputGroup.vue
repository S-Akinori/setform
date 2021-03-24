<template>
    <div class="my-5 flex justify-center">
        <div class="w-full">
            <h2 class="text-xl text-center py-3 w-full rounded-lg bg-blue-100">{{inputGroup.title}}<span v-if="inputGroup.validation.required" class="text-red-500"> *</span></h2>

            <!-- checkbox and radio button -->
            <div v-if="inputGroup.type == 'checkbox' || inputGroup.type == 'radio' " class="flex justify-center">
                <div class="w-full my-3 mx-5 md:w-3/4">
                    <custom-check :inputGroupId="inputGroup.id" :type="inputGroup.type" :name='inputGroup.name' :inputs="inputGroup.inputs" @input="updateValue" v-bind:class="inputGroup.validation"></custom-check>
                    <ul class="error" v-if="errors">
                        <li v-for="(error, index) in errors" v-bind:key="index" class="text-red-500">{{error}}</li>
                    </ul>
                    <div v-if="inputGroup.description" class="w-full text-gray-700">{{inputGroup.description}}</div>
                </div>
            </div>

            <!-- textarea -->
            <div v-else-if="inputGroup.type == 'textarea'" class="flex justify-center">
                <div class="w-full mx-5 md:w-3/4">
                    <div v-for="(input, index) in inputGroup.inputs" v-bind:key="input.id" class="my-3">
                        <label :for="'input' + inputGroup.id + '_' + input.id">{{input.label}}</label>
                        <custom-textarea :id="'input' + inputGroup.id + '_' + input.id" :name='inputGroup.name' :value="value" @input="updateValue" class="my-3 py-1 w-full" v-bind:class="inputGroup.validation"></custom-textarea>
                    </div>
                    <ul class="error" v-if="errors">
                        <li v-for="(error, index) in errors" v-bind:key="index" class="text-red-500">{{error}}</li>
                    </ul>
                    <div v-if="inputGroup.description" class="w-full text-gray-600">{{inputGroup.description}}</div>
                </div>
            </div>

            <!-- text -->
            <div v-else class="flex justify-center">
                <div class="w-full mx-5 md:w-3/4">
                    <custom-input :inputs="inputGroup.inputs" :name='inputGroup.name' :inputGroupId="inputGroup.id" :type="inputGroup.type" @input="updateValue" v-bind:class="inputGroup.validation"></custom-input>
                    <ul class="error" v-if="errors">
                        <li v-for="(error, index) in errors" v-bind:key="index" class="text-red-500">{{error}}</li>
                    </ul>
                    <div v-if="inputGroup.description" class="w-full text-gray-600">{{inputGroup.description}}</div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import CustomTextarea from './CustomTextarea.vue'
import CustomInput from './CustomInput.vue'
import CustomRadio from './CustomRadio.vue'
import CustomCheck from './CustomCheck.vue'

export default {

    props: ['inputGroup', 'value', 'errors'],

    data: function() {
        return {
            nextInputId: 1
        }
    },
    components: {
        CustomInput,
        CustomTextarea,
        CustomCheck
    },
    methods: {
       updateValue(value) {
           this.$emit('input', value)
       }
    },
}
</script>