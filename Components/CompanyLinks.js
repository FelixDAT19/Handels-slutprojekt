import {useRouter} from 'next/router'

function CompanyLinks({location}){ //maps out all locations where there is a company

    const router = useRouter();
    
    return location.map(({ id, companyId, mapLocation }, i) => {
        if (companyId !== null) {
            return (
                   
                <area shape="rect" coords={mapLocation} alt={id} href={`/company/${companyId}`}/>     

            );
        }
    });
    

}
export default CompanyLinks;

/*                <div key={i}>
                    <button
                    id={id}
                    onClick={() =>
                        router.push({ pathname: `/company/${companyId}`})
                    }
                    >
                    {id}
                    </button>
                    <br />
                </div> */