import {ref, toValue} from "vue";;

export default function usePost(url) {

    const isLoading = ref(false);

    const addData = (data, additionalLoader = null) => {
        isLoading.value = true;
        if(additionalLoader) additionalLoader.value = true;
        axios.post(toValue(url), data)
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.log(err);
            })
            .finally(() => {
                isLoading.value = false;
                if(additionalLoader) additionalLoader.value = false;
            })
    }


    return { isLoading, addData };

}
