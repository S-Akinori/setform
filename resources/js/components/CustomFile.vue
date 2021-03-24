<template>
    <input
        :id="id"
        :type="type"
        :name="name"
        :value="value"
        :placeholder="placeholder"
        ref="file"
        class="block border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400"
        @change="updateValue"
    />
</template>

<script>
export default {
    props: ['id', 'type', 'name', 'value', 'placeholder'],

    methods: {
        updateValue(e) {
            if(this.type == 'file') {
                this.$emit("input", e.target.files[0]);
            } else {
                this.$emit("input", e.target.value)
            }
        }
    }
}
</script>