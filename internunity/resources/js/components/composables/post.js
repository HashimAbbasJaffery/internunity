import {reactive, ref, toValue} from "vue";;

export default function usePost(url) {

    const isLoading = ref(false);
    const errors = ref({});

    const addData = (data, additionalLoader = null) => {
        isLoading.value = true;
        if(additionalLoader) additionalLoader.value = true;
        axios.post(toValue(url), data)
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.log(err);
                if(err.status !== 422) return;
                errors.value = {...err.response.data.errors};
            })
            .finally(() => {
                isLoading.value = false;
                if(additionalLoader) additionalLoader.value = false;
            })
    }


    return { isLoading, addData, errors };

}
