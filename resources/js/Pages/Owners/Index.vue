<template>
    <div>Hello World</div>
</template>

<script>
import Owner from "@/Components/Owner";

defineProps(['owners'])
export default {
    name: "Index",
    components: {Owner}
}
</script>

<style scoped>

</style>
