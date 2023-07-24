import axios from 'axios';

axios.defaults.headers.common = {
    "Content-Type": "application/json;charset=utf-8",
};

export const getAllProducts = async () => {

    const response= await axios.get('/api/users/profile/admin/allProducts');
    return response.data?.item;
}
export const editProducts = async (id, name, size, sex, category, type, price, count, composition, main_photo,
                                   first_sec_photo, second_sec_photo) => {

    const response = await axios.get(
        '/api/users/profile/admin/editProducts?itemId=' + id + '&name=' + name +
                                                                    '&size=' + size + '&sex=' + sex +
                                                                    '&category=' + category + '&type=' + type +
                                                                    '&price=' + price + '&count=' + count +
                                                                    '&composition=' + composition + '&main_photo=' + main_photo +
                                                                    '&first_sec_photo=' + first_sec_photo + '&second_sec_photo=' + second_sec_photo);
    return response.data;
}

export const deleteProducts = async (id) => {
    const response = await axios.delete(
        '/api/users/profile/admin/deleteProducts', {data: {id}});
    console.log(response.data);
    return response.data;
}
