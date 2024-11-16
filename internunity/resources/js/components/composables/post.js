import {ref, toValue} from "vue";;

export default function usePost(url) {

    const isLoading = ref(false);
    const errors = ref({});
    const returns = ref({});

    const addData = (data, additionalLoader = null) => {
        isLoading.value = true;
        if(additionalLoader) additionalLoader.value = true;
        axios.post(toValue(url), data)
            .then(res => {
                returns.value = res
            })
            .catch(err => {
                if(err.status !== 422) return;
                errors.value = {...err.response.data.errors};
            })
            .finally(() => {
                isLoading.value = false;
                if(additionalLoader) additionalLoader.value = false;
            })
    }

    const sendRequest = (data, additionalLoader = null) => {
        addData(data, additionalLoader);
    }


    return { isLoading, sendRequest, errors, returns };

}
