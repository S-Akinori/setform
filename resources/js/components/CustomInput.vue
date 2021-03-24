<template>
<div>
    <div v-for="(input, index) in inputs" v-bind:key="input.id">
        <label :for="'input' + inputGroupId + '_' + input.id">{{input.label}}</label>
        <input
            v-if="type == 'file'"
            :id="'input' + inputGroupId + '_' + input.id"
            :type="type"
            :name="name"
            :value="value"
            :placeholder="placeholder"
            class="block w-full my-3 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400"
            @change="updateValue"
        />

        <input
            v-else
            :id="'input' + inputGroupId + '_' + input.id"
            :type="type"
            :name="name"
            :value="value"
            :placeholder="placeholder"
            class="block w-full border my-3 py-1 border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400"
            @input="updateValue"
        />
    </div>
</div>
</template>

<script>
export default {
    props: ['inputs', 'inputGroupId', 'type', 'name', 'value', 'placeholder'],
    data() {
        return {
            values: {}
        }
    },
    methods: {
        updateValue(e) {
            if(this.inputs.length > 1) {// with confirmation 
                if(this.type == 'file') {
                    this.$set(this.values, e.target.id, e.target.files[0])
                    this.$emit("input", this.values);
                } else {
                    this.$set(this.values, e.target.id, e.target.value)
                    this.$emit("input", this.values);
                }
            } else {
                if(this.type == 'file') {
                    this.$emit("input", e.target.files[0]);
                } else {
                    this.$emit("input", e.target.value);
                }
            }
        }
    },
}
</script>