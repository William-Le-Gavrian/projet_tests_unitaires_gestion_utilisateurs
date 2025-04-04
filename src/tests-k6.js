import http from 'k6/http';
import { check } from 'k6';

export const options = {
    vus: 500,
    duration: '1m',
};

export default function () {
    const url = 'http://127.0.0.1:8000/api.php';

    const payload = JSON.stringify({
        name: `User${Math.random().toString(36).substr(2, 5)}`,
        email: `user_${Math.random().toString(36).substr(2, 5)}@example.com`,
        age: `${Math.floor(Math.random() * 101)}`
    });

    const params = {
        headers: {
            'Content-Type': 'application/json',
        },
    };

    const response = http.post(url, payload, params);

    check(response, {
        'Statut 200': (r) => r.status === 200,
        'Reponse rapide (<500ms)': (r) => r.timings.duration < 500,
    });
}