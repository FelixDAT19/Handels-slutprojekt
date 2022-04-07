import {useRouter} from 'next/router'

function CompanyLinks({location}){ //maps out all locations where there is a company

    const router = useRouter();

    return location.map(({ id, companyId }, i) => {
        if (companyId !== null) {
            return (
                
                <div key={i}>
                    <button
                    id={id}
                    onClick={() =>
                        router.push({ pathname: `/company/${companyId}`})
                    }
                    >
                    {id}
                    </button>
                    <br />
                </div>
                
            );
        }
    });
    

}
export default CompanyLinks;