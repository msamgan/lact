import { execSync } from 'node:child_process';

export const lactPreBuild = () => {
    return {
        name: 'lact-pre-build',
        buildStart() {
            execSync('./vendor/bin/lact', { stdio: 'inherit' });
        }
    };
};
