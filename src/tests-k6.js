import http from 'k6/http';
import { sleep, check } from 'k6';

export const options = {
    vus: 500,
    duration: '1m',
};

export default function () {

    const url = 'http://localhost/projet_tests_unitaires_gestion_utilisateurs/api.php';

    let data = {
        name: `User${Math.random().toString(36).substr(2, 5)}`,
        email: `user_${Math.random().toString(36).substr(2, 5)}@example.com`,
        age: `${Math.floor(Math.random() * 101)}`
    };

    const response = http.post(url, data);

    check(response, {
        'Statut 200': (r) => r.status === 200,
        'Reponse rapide (<500ms)': (r) => r.timings.duration < 500,
    });
}