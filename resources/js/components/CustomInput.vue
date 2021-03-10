<template>
    <input
        :id="id"
        :type="type"
        :name="name"
        :value="value"
        :placeholder="placeholder"
        class="block border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400"
        @input="updateValue"   
    />
</template>

<script>
export default {
    props: ['id', 'type', 'name', 'value', 'placeholder'],

    methods: {
        updateValue(e) {
            this.$emit("input", e.target.value)
        }
    }
}
</script>