
Vue.http.interceptors.push((request, next) => {

    // For Api Package Auth
    request.headers.set('Accept', 'application/json');
    request.headers.set('Authorization', 'Bearer ' + document.querySelector('meta[name="_api_token"]')['content']);

    // For Datatables Api Package Repo
    request.headers.set('Site-Controller-Path', document.querySelector('meta[name="_controller_path"]')['content']);
    request.headers.set('Site-Repo-Path', document.querySelector('meta[name="_repo_path"]')['content']);
    // request.headers.set('Site-Request-Path', document.querySelector('meta[name="_request_path"]')['content']);
    request.headers.set('Site-Route-Name', document.querySelector('meta[name="_route_name"]')['content']);

    next();

})


// localStorage.clear();
console.log('localStorage:');
console.log(Object.keys(localStorage));
console.log(Object.values(localStorage));


