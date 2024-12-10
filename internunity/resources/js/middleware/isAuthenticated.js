export default function isAuthenticated(to, from, next) {
    const is_user = window.location.href.split("/")[3];
    let token_key = is_user === 'company' ? 'company_token' : 'token';
    let name = 'home';
    const token = localStorage.getItem(token_key);
    if(is_user === 'company') name = 'company';
    if(token) {
        return next({ name: name });
    } else {
        return next()
    }
}
