<template>
    <textarea :name="name" :id="id" rows="5" class="block border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400"></textarea>
</template>

<script>
export default {
    props: ['id', 'name']
}
</script>