<script>
export default {
    created() {
        window.localStorage.removeItem('token');
        Vue.router.push('/');
    }
}
</script>
