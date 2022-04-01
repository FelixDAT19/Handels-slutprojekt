import {useRouter} from 'next/router'

function CompanyLinks({location}){

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