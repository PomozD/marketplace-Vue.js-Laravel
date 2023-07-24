import axios from 'axios';

axios.defaults.headers.common = {
    "Content-Type": "application/json;charset=utf-8",
};

export const getUser = async (email, password) => {
    const response = await axios.get('/api/users?email=' + email + '&password=' + password );
    console.log(response);
    return response.data;
}

export const postUser = async (name, surname, email, password) => {
    const data = {
        name,
        surname,
        email,
        password,
    };
    const response = await axios.post("/api/users", data, {
        headers: {
            "Content-Type": "application/json;charset=utf-8",
        }
    });

    console.log(response);

    return response.data;
}
