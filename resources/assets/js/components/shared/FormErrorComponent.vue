<template>
    <span class="help-block text-danger">
        <slot></slot>
    </span>
</template>

<script>
    export default {
        props: ['errors'],
    }
</script>