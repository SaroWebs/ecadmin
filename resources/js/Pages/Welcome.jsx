import { Link, Head } from '@inertiajs/react';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Welcome" />
            <main className="min-h-screen flex flex-col justify-center items-center">
                <div className="">
                    <h3 className="text-3xl text-slate-600">Admin Panel</h3>
                    <p className="text-xl text-slate-300">
                        Work in progress..
                    </p>
                </div>
            </main>
        </>
    );
}
