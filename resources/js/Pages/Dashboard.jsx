import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="w-full mx-auto sm:px-6 lg:px-8">
                    Dashboard
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
