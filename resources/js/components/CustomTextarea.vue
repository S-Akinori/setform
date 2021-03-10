<template>
    <textarea 
        :id="id"
        :name="name"
        :placeholder="placeholder"
        :value="value"
        rows="5" 
        class="block border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400"
        @input="updateValue"></textarea>
</template>

<script>
export default {
    props: ['id', 'name', 'value', 'placeholder'],
    methods: {
        updateValue(e) {
            this.$emit("input", e.target.value)
        }
    }
}
</script>