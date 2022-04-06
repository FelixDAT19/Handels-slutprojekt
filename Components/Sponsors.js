
function Sponsors({sponsors}){
    
    return(
        <div id="sponsor">

            {sponsors.map(({logoUrl,sponsorUrl,name}, i) => ( //maps out sponsors
                <div key={i}>
                    
                    <a passHref={true} href={sponsorUrl} className="sponsorImage" dangerouslySetInnerHTML={{__html: logoUrl}}/>
                    <p className="sponsorInfo">{name}</p>
                    <br/>
                </div>
            ))}

        </div>
    )

}

export default Sponsors;