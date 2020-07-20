import http from "../util/http";

const employees = {
    find: id => {
        return http.get(`employees/${id}`);
    },
    all: () => {
        return http.get('employees')
    },
    create: data => {
        return http.post('employees',data)
    },
    edit: (id, data) => {
        return http.put(`employees/${id}`,data)
    },
    delete: id => {
        return http.delete(`employees/${id}`)
    }
};

export default employees;