import { execSync } from 'node:child_process';

export const lactPreBuild = () => {
    return {
        name: 'lact-pre-build',
        async buildStart() {
            execSync('php artisan lact:run', { stdio: 'inherit' });
        }
    };
};
