<template>
    <div>
        <div v-for="(option, index) in options" v-bind:key="option.id">
            <input 
                :id="option.id"
                :type="type"
                :name="name"
                :value="option.value"
                @change="updateValue"
            />
            <label :for="option.id">{{option.label}}</label>
        </div>
    </div>
</template>

<script>
export default {
    props: ['type', 'name', 'options'],
    methods: {
        updateValue(e) {
            this.$emit('input', e.target.value)
        }
    }
}
</script>