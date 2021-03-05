<template>
    <input v-bind:id="id" :type="type" :name="name" value="" class="block border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400">
</template>

<script>
export default {
    props: ['id', 'type', 'name']
}
</script>