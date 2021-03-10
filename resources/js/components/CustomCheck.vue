<template>
    <div>
        <div v-for="(input, index) in inputs" v-bind:key="input.id">
            <input 
                :id="'input' + inputGroupId + '_' + input.id"
                :type="type"
                :name="name"
                :value="input.label"
                @change="updateValue"
            />
            <label :for="'input' + inputGroupId + '_' + input.id">{{input.label}}</label>
        </div>
    </div>
</template>

<script>
export default {
    props: ['inputGroupId', 'type', 'name', 'inputs'],

    data() {
        return {
            values: []
        }
    },
    methods: {
        updateValue(e) {
            if(e.target.type == 'radio') {
                this.$emit('input', e.target.value)
            } else {
                if(e.target.checked) {
                    this.values.push(e.target.value)
                } else {
                    this.values = this.values.filter(v => v !== e.target.value)
                }
                this.$emit('input', this.values);
            }
        }
    }
}
</script>