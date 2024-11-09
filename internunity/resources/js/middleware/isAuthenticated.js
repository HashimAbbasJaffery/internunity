export default function isAuthenticated(to, from, next) {
    const token = localStorage.getItem("token");
    if(token) {
        return next({ name: 'home' });
    } else {
        return next()
    }
}
