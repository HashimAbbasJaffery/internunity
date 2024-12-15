import {ref, toValue} from "vue";;

export default function usePost(url) {

    const isLoading = ref(false);
    const errors = ref({});
    const returns = ref({});

    const addData = (data, additionalLoader = null, callback = null) => {
        isLoading.value = true;
        let hasErrors = false;
        if(additionalLoader) additionalLoader.value = true;
        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
        axios.post(toValue(url), data, config)
            .then(res => {
                console.log(res);
                returns.value = res
                callback && callback(res);
            })
            .catch(err => {
                console.log(err);
                if(err.status !== 422) return;
                errors.value = {...err.response.data.errors};
                (Object.keys(err.response.data.errors).length) ? hasErrors = true : hasErrors = false
            })
            .finally(() => {
                isLoading.value = false;
                if(additionalLoader) additionalLoader.value = false;
            });
        return hasErrors;
    }

    const sendRequest = (data, callback = null, additionalLoader = null) => {
        addData(data, additionalLoader, callback);
    }


    return { isLoading, sendRequest, errors, returns };

}
