import {ref, toValue} from "vue";;

export default function usePost(url) {

    const isLoading = ref(false);
    const errors = ref({});
    const returns = ref({});

    const addData = (data, additionalLoader = null) => {
        isLoading.value = true;
        let hasErrors = false;
        if(additionalLoader) additionalLoader.value = true;
        axios.post(toValue(url), data)
            .then(res => {
                returns.value = res
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

    const sendRequest = (data, additionalLoader = null) => {
        console.log(addData(data, additionalLoader));
    }


    return { isLoading, sendRequest, errors, returns };

}
