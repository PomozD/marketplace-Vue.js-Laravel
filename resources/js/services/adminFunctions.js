import axios from 'axios';

axios.defaults.headers.common = {
    "Content-Type": "application/json;charset=utf-8",
};

export const getCategory = async () => {
    const response = await axios.get('/api/users/profile/admin/getCategory');
    return response.data?.item;
}

export const getSex = async () => {
    const response = await axios.get('/api/users/profile/admin/getSex');
    console.log(response);
    return response.data?.item;
}

export const getSize = async () => {
    const response = await axios.get('/api/users/profile/admin/getSize');
    console.log(response);
    return response.data?.item;
}

export const getType = async (categoryName) => {
    const response = await axios.get('/api/users/profile/admin/getType?categoryname=' + categoryName);
    console.log(response);
    return response.data?.item;
}

export const addProduct = async (item_name, item_size, item_sex, item_category, item_type, item_price, item_count, item_composition, item_mainPhoto, item_fsPhoto, item_ssPhoto) => {
    const data = {
        item_name,
        item_size,
        item_sex,
        item_category,
        item_type,
        item_price,
        item_count,
        item_composition,
        item_mainPhoto,
        item_fsPhoto,
        item_ssPhoto
    };
    const response = await axios.post('/api/users/profile/admin/addProduct', data, {
        headers: {
            "Content-Type": "application/json;charset=utf-8",
        }
    });
    console.log(response.data);
    return response.data;
}

export const addCategory = async (categoryName) => {
    const data = {
        categoryName
    };
    const response = await axios.post('/api/users/profile/admin/addCategory', data);
    console.log(response);
    return response.data;
}

export const deleteCategory = async (categoryName) => {
    const response = await axios.delete('/api/users/profile/admin/deleteCategory', {data: {categoryName}});
    console.log(response);
    return response.data;
}

export const addType = async (categoryName, type) => {
    const data = {
        categoryName,
        type
    };
    const response = await axios.post('/api/users/profile/admin/addType', data);
    console.log(response.data);
    return response.data;
}

export const deleteType = async (categoryName, type) => {
    const response = await axios.delete('/api/users/profile/admin/deleteType', {data: {categoryName, type}});
    console.log(response.data);
    return response.data;
}

