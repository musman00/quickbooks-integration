import GuestLayout from '@/Layouts/GuestView.jsx';
import {Button} from "antd";
import React from "react";

export default function QuickBookLogin() {
    const submit = (e) => {
        e.preventDefault();

        window.location = route("quickbook-oauth.connect");
    };

    return (
        <GuestLayout>
            <Button size={ "large" } onClick={submit} color="primary" variant="outlined" className={"mb-3"}>
                <img src={"/images/quickbook-logo.png"} width={120} className="mx-auto ms-2"/>
                <span className="ms-2">Login with QuickBooks</span>
            </Button>
        </GuestLayout>
    );
}
